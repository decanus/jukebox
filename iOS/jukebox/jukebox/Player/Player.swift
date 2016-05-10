//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Player: PlayerProtocol {
    
    // EXPERIMENTAL
    private let youtubePlayer: YoutubePlayer
    
    init(youtubePlayer: YoutubePlayer) {
        self.youtubePlayer = youtubePlayer
    }
    
    func play() {
        self.youtubePlayer.play()
    }
    
    func pause() {
        self.youtubePlayer.pause()
    }
    
    func next() {
        
    }
    
    func previous() {
        
    }
    
    func playTrack(track: Track) {
        if track is YoutubeTrack {
            youtubePlayer.setTrack(track)
        }
        
        play()
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