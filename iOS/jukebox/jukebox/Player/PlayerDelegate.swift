//
//  PlayerDelegate.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import AVFoundation

protocol PlayerDelegate: class {
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime)
    
    func player(player: Player, canPresentVideoLayer videoLayer: AVPlayerLayer)
    
}