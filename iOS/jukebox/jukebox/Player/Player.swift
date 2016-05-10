//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Player: NSObject, PlayerProtocol {
    
    // EXPERIMENTAL
    private let youtubePlayer: YoutubePlayer
    private var currentTrack: Track?
    
    init(youtubePlayer: YoutubePlayer) {
        self.youtubePlayer = youtubePlayer
    }
    
    func play() {
        if currentTrack is YoutubeTrack {
            youtubePlayer.play()
        }
    }
    
    func pause() {
        if currentTrack is YoutubeTrack {
            youtubePlayer.pause()
        }
    }
    
    func next() {
        
    }
    
    func previous() {
        
    }
    
    func playTrack(track: Track) {
        if track is YoutubeTrack {
            youtubePlayer.setTrack(track)
        }
        
        currentTrack = track
        
        play()
    }
    
    func getNowPlaying() -> Track {
        return currentTrack!
    }
    
    func getPlaybackState() -> PlaybackState {
        return .Stopped
    }
    
    func getRepeatMode() -> RepeateMode {
        return .None
    }
    
}