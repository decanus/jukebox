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
    private let title: String
    
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
    
    func getDuration() -> NSTimeInterval {
        return duration
    }
    
    func getPlatform() -> Platform {
        return .Youtube
    }
    
}