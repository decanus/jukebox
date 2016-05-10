//
//  ViewControllerFactory.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class ViewControllerFactory {
    
    class func createMainViewController() -> MainViewController {
        return MainViewController(player: PlayerFactory.createPlayer())
    }
    
//    class func createPlayerViewController() -> PlayerViewController {
//        return PlayerViewController(player: Player(youtubePlayer: YoutubePlayer()))
//    }
    
    class func createPlaylistViewController() -> PlaylistViewController {
        return PlaylistViewController()
    }
    
}