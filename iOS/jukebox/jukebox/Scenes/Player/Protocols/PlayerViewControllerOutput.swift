//
//  PlayerViewControllerOutput.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

protocol PlayerViewControllerOutput {
 
    func pausePressed()
    
    func nextPressed()
    
    func backPressed()
    
    func closePressed()
    
    func viewDidLoad()
    
}