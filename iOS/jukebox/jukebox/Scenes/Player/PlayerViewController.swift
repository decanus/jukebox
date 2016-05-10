//
//  PlayerViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class PlayerViewController: UIViewController {
    
    private let player: Player
    
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        navigationController?.navigationBarHidden = true

        view.backgroundColor = UIColor.whiteColor()
        
        // @todo presenter und so        
        if player.hasVideoView() {
            player.addVideoToView(view, frame: CGRect(x: 0, y: view.frame.size.height - 200, width: view.frame.size.width, height: 200))
        }
                
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
