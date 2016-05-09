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
        return MainViewController()
    }
    
    class func createPlayerViewController() -> PlayerViewController {
        return PlayerViewController(player: Player())
    }
    
    class func createPlaylistViewController() -> PlaylistViewController {
        return PlaylistViewController()
    }
    
}