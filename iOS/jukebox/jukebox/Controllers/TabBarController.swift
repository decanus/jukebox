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
        
        let test = UIView(frame: CGRect(x: 0, y: view.frame.size.height - (tabBar.frame.size.height * 2), width: view.frame.size.width, height: tabBar.frame.size.height))
        test.backgroundColor = tabBar.backgroundColor
        view.addSubview(test)
        
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.selectedIndex = 0
    }
}
