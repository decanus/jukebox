//
//  PlayerPresenterOutput.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

protocol PlayerPresenterOutput: class {
    
    func setPlayerProgressSliderValue(value: Float)
    
    func setMaximumSliderValue(value: Float)
    
    func updateElapsedTimeLabel(elapsedTime: String)
    
    func updateDurationLabel(duration: String)
    
    func frameForVideoLayer() -> CGRect
    
    func appendPlayerVideoToCoverView(playerVideo: UIView)
    
    func setTrackTitle(title: String)
    
    func setCurrentPlatform(platform: Platform)
    
    func updatePlaybackState(state: PlaybackState)
    
}