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
class YoutubePlayer: NSObject, PlayerProtocol {
    
    private let player: Player
    private var loaded = false
    private let playerView: AVPlayerViewController
    private var playerLayer: AVPlayerLayer?
    private var observer: AnyObject?
    
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
        XCDYouTubeClient.defaultClient().getVideoWithIdentifier(track.getID()) { [weak playerView] (video: XCDYouTubeVideo?, error: NSError?) in
            if let streamURL = (video?.streamURLs[XCDYouTubeVideoQualityHTTPLiveStreaming] ??
                video?.streamURLs[XCDYouTubeVideoQuality.HD720.rawValue] ??
                video?.streamURLs[XCDYouTubeVideoQuality.Medium360.rawValue] ??
                video?.streamURLs[XCDYouTubeVideoQuality.Small240.rawValue]) {
                
                if playerView!.player != nil {
                    NSNotificationCenter.defaultCenter().removeObserver(self)
                    self.playerView.player?.replaceCurrentItemWithPlayerItem(AVPlayerItem(URL: streamURL))
                } else {
                    playerView?.player = AVPlayer(URL: streamURL)
                }
                
                // todo, remove observer when done
                self.observer = self.playerView.player?.addPeriodicTimeObserverForInterval(CMTimeMake(33, 1000), queue: dispatch_get_main_queue(), usingBlock: {
                    time in                    
                    self.player.updateTime(
                        Float(CMTimeGetSeconds(time)),
                        duration: Float(CMTimeGetSeconds((playerView!.player?.currentItem?.duration)!))
                    )
                })
                
                NSNotificationCenter.defaultCenter().addObserver(self, selector: #selector(self.itemDidFinishPlaying), name: AVPlayerItemDidPlayToEndTimeNotification, object: playerView?.player?.currentItem)
                
                dispatch_async(dispatch_get_main_queue(), {
                    self.player.addPlayer()
                    playerView?.player?.play()
                })
            }
        }
    }
    
    func itemDidFinishPlaying(note: NSNotification) {
        playerView.player?.removeTimeObserver(self.observer!)
        self.player.next()
    }
    
    func appendPlayerToView(view: UIView) {
        playerLayer = AVPlayerLayer(player: playerView.player)
        playerLayer!.frame = view.frame
        playerLayer?.videoGravity = AVLayerVideoGravityResizeAspectFill
        let playerVideo = UIView(frame: view.frame)
        playerVideo.layer.addSublayer(playerLayer!)
        view.addSubview(playerVideo)
        playerView.player?.play()
    }
    
    func enterForeground() {
        playerLayer?.player = playerView.player
    }
    
    func removePlayerLayer() {
        if playerLayer != nil {
            playerLayer?.player = nil
        }
    }
}