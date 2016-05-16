//
//  YoutubeTrack.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class YoutubeTrack: NSObject, Track {
    
    private let id: String
    private var duration: NSTimeInterval
    
    init(id: String) {
        duration = 0
        self.id = id
    }
    
    func getID() -> String {
        return self.id
    }
    
    func getTitle() -> String {
        return "Better"
    }
    
    func getArtist() -> String {
        return "Jukebox Ninja"
    }
    
    func getDuration() -> NSTimeInterval {
        return duration
    }
    
    func setDuration(duration: NSTimeInterval) {
        self.duration = duration
    }
    
    func getPlatform() -> Platform {
        return .Youtube
    }
    
}