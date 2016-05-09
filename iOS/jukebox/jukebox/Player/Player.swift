//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Player: PlayerProtocol {
    
    func play() {
        
    }
    
    func pause() {
        
    }
    
    func next() {
        
    }
    
    func previous() {
        
    }
    
    
    func getNowPlaying() -> Track {
        return YoutubeTrack()
    }
    
    func getPlaybackState() -> PlaybackState {
        return .Stopped
    }
    
    func getRepeatMode() -> RepeateMode {
        return .None
    }
    
}