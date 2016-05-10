//
//  Player.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class Player: NSObject, PlayerProtocol {
    
    // EXPERIMENTAL, CLEANUP
    var youtubePlayer: YoutubePlayer! = nil
    private var currentTrack: Track?
    private var currentTrackIndex: Int? = nil
    private var playbackState: PlaybackState = .Stopped
    private var queue: Queue?
    
    func setQueue(queue: Queue) {
        self.queue = queue
    }
    
    func play() {
        
        if playbackState == .Playing {
            return
        }
        
        if playbackState == .Stopped {
            next()
        }
        
        if currentTrack is YoutubeTrack {
            youtubePlayer.play()
        }
        
        playbackState = .Playing
    }
    
    func pause() {
        if currentTrack is YoutubeTrack {
            youtubePlayer.pause()
        }
    }
    
    func next() {
        
        if !queue!.hasNext() {
            playbackState = .Stopped
            return
        }
        
        playTrack(queue!.getNextTrack())
    }
    
    func previous() {
        
    }
    
    func playTrack(track: Track) {
        if track is YoutubeTrack {
            youtubePlayer.setTrack(track)
            youtubePlayer.play()
        }
        
        currentTrack = track
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