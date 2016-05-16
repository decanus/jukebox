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
    
    init(id: String) {
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
        return 0
    }
    
    func getPlatform() -> Platform {
        return .Youtube
    }
    
}