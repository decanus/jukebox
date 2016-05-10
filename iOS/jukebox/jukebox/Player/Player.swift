//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class Player: NSObject, PlayerProtocol {
    
    // EXPERIMENTAL
    var youtubePlayer: YoutubePlayer! = nil
    private var currentTrack: Track?
    private var currentTrackIndex: Int? = nil
    
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
        playTrack(YoutubeTrack(id: "Twix375Me4Q"))
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
    
    func hasVideoView() -> Bool {
        return currentTrack is YoutubeTrack
    }
    
    func addVideoToView(view: UIView, frame: CGRect) {
        
        if currentTrack is YoutubeTrack {
            youtubePlayer.appendPlayerToView(view, frame: frame)
        }
        
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