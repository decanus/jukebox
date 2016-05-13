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
        let viewController = PlayerViewController()
        let presenter = PlayerPresenter(output: viewController)
        let interactor = PlayerInteractor(output: presenter, player: PlayerFactory.createPlayer())
        viewController.output = interactor
        
        PlayerFactory.createPlayer().delegate = presenter
        
        return viewController
    }
    
    class func createPlaylistViewController() -> PlaylistViewController {
        return PlaylistViewController()
    }
    
}