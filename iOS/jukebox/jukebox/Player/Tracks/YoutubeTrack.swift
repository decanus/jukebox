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
    private let duration: NSTimeInterval
    
    init(id: String, duration: NSTimeInterval) {
        self.id = id
        self.duration = duration
    }
    
    func getID() -> String {
        return self.id
    }
    
    func getTitle() -> String {
        return "Better"
    }
    
    func getDuration() -> NSTimeInterval {
        return duration
    }
    
    func getPlatform() -> Platform {
        return .Youtube
    }
    
}