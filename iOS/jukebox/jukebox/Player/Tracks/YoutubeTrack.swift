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
    private let title: String
    private var duration: NSTimeInterval
    
    init(id: String, duration: NSTimeInterval, title: String = "Better") {
        self.id = id
        self.duration = duration
        self.title = title
    }
    
    func getID() -> String {
        return id
    }
    
    func getTitle() -> String {
        return title
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