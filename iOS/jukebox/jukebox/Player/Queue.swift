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
    
    func addTrack(track: Track) {
        queue.append(track)
    }
    
}
