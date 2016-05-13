//
// Created by Dean Eigenmann on 09/05/16.
// Copyright (c) 2016 jukebox. All rights reserved.
//

import UIKit

class TabBarController: UITabBarController, UITabBarControllerDelegate {

    private let player: Player
    
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
        delegate = self
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.selectedIndex = 0
    }
    
    func tabBarController(tabBarController: UITabBarController, shouldSelectViewController viewController: UIViewController) -> Bool {

        // ugly hack
        if viewController is PlayerViewController {
            presentViewController(ViewControllerFactory.createPlayerViewController(), animated: true, completion: nil)
            return false
        }
        
        return true
    }
}
