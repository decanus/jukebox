//
//  YoutubePlayer.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import AVKit
import XCDYouTubeKit

// @todo, figure out how to queue objects
// @todo, playerlayer code still very buggy
// @todo, play in AVQueuePlayer, can solve a lot of issues
// @todo, update, don't always add playerlayers
class YoutubePlayer: NSObject, PlayerProtocol {
    
    // remove observer once duration is in Track object
    private let player: Player
    private var loaded = false
    private let playerView: AVPlayerViewController
    private var playerLayer: AVPlayerLayer?
    private var observer: AnyObject?
    private var track: Track!
    
    init(player: Player) {
        self.player = player
        playerView = AVPlayerViewController()
        playerView.showsPlaybackControls = false
        super.init()
    }
    
    func pause() {
        playerView.player?.pause()
    }
    
    func play() {
        playerView.player?.play()
    }
    
    func setTrack(track: Track) {
        self.track = track
        
        XCDYouTubeClient.defaultClient().getVideoWithIdentifier(track.getID()) { [weak self] (video: XCDYouTubeVideo?, error: NSError?) in
            if let streamURL = (video?.streamURLs[XCDYouTubeVideoQualityHTTPLiveStreaming] ??
                video?.streamURLs[XCDYouTubeVideoQuality.HD720.rawValue] ??
                video?.streamURLs[XCDYouTubeVideoQuality.Medium360.rawValue] ??
                video?.streamURLs[XCDYouTubeVideoQuality.Small240.rawValue]) {
                
                if self!.playerView.player != nil {
                    NSNotificationCenter.defaultCenter().removeObserver(self!)
                    self!.playerView.player?.replaceCurrentItemWithPlayerItem(AVPlayerItem(URL: streamURL))
                } else {
                    self!.playerView.player = AVPlayer(URL: streamURL)
                }

                self!.track.setDuration((video?.duration)!)
                self!.player.delegate?.player(self!.player, shouldUpdateTrack: self!.track)

                self!.observer = self!.playerView.player?.addPeriodicTimeObserverForInterval(CMTimeMake(33, 1000), queue: dispatch_get_main_queue(), usingBlock: {
                    time in
                    self!.player.delegate?.player(self!.player, shouldUpdateElapsedTime: time)
                })
                
                NSNotificationCenter.defaultCenter().addObserver(
                    self!,
                    selector: #selector(self!.itemDidFinishPlaying),
                    name: AVPlayerItemDidPlayToEndTimeNotification,
                    object: self!.playerView.player?.currentItem
                )
                
                dispatch_async(dispatch_get_main_queue(), {
                    self?.presentVideoLayer()
                    self!.playerView.player?.play()
                })
                self!.playerView.player?.play()

            }
        }
    }
    
    func showElapsed() {
        self.player.delegate?.player(self.player, shouldUpdateElapsedTime: (self.playerView.player?.currentItem?.currentTime())!)
    }
    
    func presentVideoLayer() {
        playerLayer = AVPlayerLayer(player: playerView.player)
        player.delegate?.player(player, canPresentVideoLayer: playerLayer!)
    }
    
    func itemDidFinishPlaying(note: NSNotification) {
        if observer != nil {
            playerView.player?.removeTimeObserver(observer!)
            observer = nil
        }
        
        player.next()
    }
    
    func enterForeground() {
        if playerLayer != nil {
            playerLayer?.player = playerView.player        
        }
    }
    
    func removePlayerLayer() {
        
        if player.getPlaybackState() == .Playing {
            playerView.player?.play()
        }
        
        if playerLayer != nil {
            playerLayer?.player = nil
        }
    }
    
    func deletePlayerLayer() {
        playerLayer?.player = nil
        playerLayer = nil
    }
}