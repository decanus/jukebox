//
//  Track.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

protocol Track {
    
    func getID() -> String
    
    func getPlatform() -> Platform
    
}