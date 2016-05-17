//
//  ViewControllerFactory.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class ViewControllerFactory {
    
    class func createMainViewController() -> MainViewController {
        return MainViewController(player: PlayerFactory.createPlayer())
    }
    
    class func createPlayerViewController() -> PlayerViewController {
        let viewController = PlayerViewController()
        let presenter = PlayerPresenter(output: viewController)
        let interactor = PlayerInteractor(output: presenter, player: PlayerFactory.createPlayer())
        viewController.output = interactor
                
        return viewController
    }

    class func createSearchViewController() -> UINavigationController {
        
        let viewController = SearchViewController()
        let presenter = SearchPresenter(output: viewController)
        let interactor = SearchInteractor(output: presenter)
        viewController.output = interactor
        
        let navigationController = UINavigationController()
        navigationController.viewControllers = [viewController]
        
        return navigationController
    }

    class func createPlaylistViewController() -> PlaylistViewController {
        return PlaylistViewController()
    }
    
}