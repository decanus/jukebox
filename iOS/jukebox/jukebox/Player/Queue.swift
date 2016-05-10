//
//  Queue.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Queue: NSObject {
    
    private var queue = [Track]()
    private var currentTrack: Int? = nil
    
    func getNextTrack() -> Track {
        if currentTrack == nil {
            currentTrack = 0
            return getTrackAtIndex(currentTrack!)
        }
        
        currentTrack? += 1
        return getTrackAtIndex(currentTrack!)
    }
    
    func getTrackAtIndex(index: Int) -> Track {
        return queue[index]
    }
    
    func hasNext() -> Bool {
        if currentTrack == nil && !queue.isEmpty {
            return true
        }
        
        return queue.count >= (currentTrack! + 2)
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
        currentTrack = nil
    }
    
}
