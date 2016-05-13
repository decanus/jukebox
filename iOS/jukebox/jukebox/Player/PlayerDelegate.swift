//
//  PlayerDelegate.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import CoreMedia

protocol PlayerDelegate {
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime)
    
}