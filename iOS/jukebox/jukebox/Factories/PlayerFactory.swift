//
//  PlayerFactory.swift
//  jukebox
//
//  Created by Dean Eigenmann on 10/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class PlayerFactory {

    private static var player: Player!
    
    class func createPlayer() -> Player {
        if player == nil {
            player = Player()
            let youtubePlayer = YoutubePlayer(player: player)
            player.youtubePlayer = youtubePlayer;
        }
        
        return player
    }
    
}
