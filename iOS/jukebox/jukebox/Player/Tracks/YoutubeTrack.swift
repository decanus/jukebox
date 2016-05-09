//
//  YoutubeTrack.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class YoutubeTrack: Track {
    
    func getID() -> String {
        return ""
    }
    
    func getTitle() -> String {
        return ""
    }
    
    func getDuration() -> NSTimeInterval {
        return 0
    }
    
    func getPlatform() -> Platform {
        return .Youtube
    }
    
}