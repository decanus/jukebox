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
                
                NSNotificationCenter.defaultCenter().addObserver(self, selector: #selector(self.itemDidFinishPlaying), name: AVPlayerItemDidPlayToEndTimeNotification, object: playerView?.player?.currentItem)
                
                dispatch_async(dispatch_get_main_queue(), {
                    playerView?.player?.play()
                })
            }
        }
    }
    
    func itemDidFinishPlaying(note: NSNotification) {
        self.player.next()
    }
    
    func appendPlayerToView(view: UIView, frame: CGRect) {
        playerView.view.frame = frame
        playerView.videoGravity = AVLayerVideoGravityResizeAspectFill
        view.addSubview(playerView.view)
    }
}