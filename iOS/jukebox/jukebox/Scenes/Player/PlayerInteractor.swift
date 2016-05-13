//
//  PlayerInteractor.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class PlayerInteractor: NSObject, PlayerViewControllerOutput {
    
    private let player: Player
    
    init(player: Player) {
        self.player = player
    }
    
    func pausePressed() {
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()
    }
    
    func nextPressed() {
        player.next()
    }
    
    func backPressed() {
        player.previous()
    }
    
}