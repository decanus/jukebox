//
//  PlayerPresenter.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import AVFoundation
import UIKit

class PlayerPresenter: NSObject, PlayerInteractorOutput {
    
    weak private var output: PlayerPresenterOutput!
    
    init(output: PlayerPresenterOutput) {
        self.output = output
    }
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime) {
        let elapsedTime = CMTimeGetSeconds(elapsedTime)
        output.setPlayerProgressSliderValue(Float(elapsedTime))
        output.updateElapsedTimeLabel(formatTime(Double(elapsedTime)))
    }
    
    func player(player: Player, shouldUpdateDuration duration: CMTime) -> Bool {
        let duration = CMTimeGetSeconds(duration)
        
        if duration.isNaN {
            return false
        }
        
        output.setMaximumSliderValue(Float(duration))
        output.updateDurationLabel(formatTime(Double(duration)))
        return true
    }
    
    func player(player: Player, canPresentVideoLayer videoLayer: AVPlayerLayer) {
        videoLayer.frame = output.frameForVideoLayer()
        videoLayer.videoGravity = AVLayerVideoGravityResizeAspectFill
        let playerVideo = UIView(frame: output.frameForVideoLayer())
        playerVideo.layer.addSublayer(videoLayer)
        output.appendPlayerVideoToCoverView(playerVideo)
    }
    
    func player(player: Player, shouldUpdateTrack track: Track) {
        output.setCurrentPlatform(track.getPlatform())
        output.setTrackTitle(track.getTitle())
    }
    
    func player(player: Player, shouldUpdatePlaybackState state: PlaybackState) {
        output.setPlaybackState(state)
    }
    
    private func formatTime(time: Double) -> String {
        let date = NSDate(timeIntervalSince1970: time)
        let formatter = NSDateFormatter()
        formatter.timeZone = NSTimeZone(name: "UTC")
        formatter.dateFormat = "mm:ss"
        return formatter.stringFromDate(date)
    }
}