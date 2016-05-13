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
    
    class func createPlayerViewController() -> PlayerViewController {
        let viewController = PlayerViewController(player: PlayerFactory.createPlayer())
        viewController.output = PlayerInteractor(player: PlayerFactory.createPlayer())
        
        return viewController
    }
    
    class func createPlaylistViewController() -> PlaylistViewController {
        return PlaylistViewController()
    }
    
}