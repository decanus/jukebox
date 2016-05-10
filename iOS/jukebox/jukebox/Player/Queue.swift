//
//  Queue.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Queue: NSObject {
    
    // @todo make this shit less ugly
    private var queue = [Track]()
    
    // set this to 0, use a getCurrentTrack function when player is stopped
    private var currentTrack = 0
    
    func getNextTrack() -> Track {
        currentTrack += 1
        return getTrackAtIndex(currentTrack)
    }
    
    func getCurrentTrack() -> Track {
        return getTrackAtIndex(currentTrack)
    }
    
    func getTrackAtIndex(index: Int) -> Track {
        return queue[index]
    }
    
    func hasNext() -> Bool {
        return queue.count >= (currentTrack + 2)
    }
    
    func addTrack(track: Track) {
        queue.append(track)
    }
    
    func removeTrack(index: Int) {
        queue.removeAtIndex(index)
    }
    
    func clearQueue() {
        queue.removeAll()
    }
    
    func rewind() {
        currentTrack = 0
    }
    
}
