//
//  Playlist.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class Playlist {
    
    private var tracks = [Track]()
    
    func getTracks() -> [Track] {
        return tracks
    }
    
    func getTotalDuration() -> NSTimeInterval {
        var duration: NSTimeInterval = 0
        
        for track in tracks {
            duration += track.getDuration()
        }
        
        return duration
    }
    
    func getTracksCount() -> Int {
        return tracks.count
    }
    
}