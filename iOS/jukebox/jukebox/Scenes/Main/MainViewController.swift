//
//  MainViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class MainViewController: UIViewController {

    override func viewDidLoad() {
        super.viewDidLoad()

        view.backgroundColor = UIColor.whiteColor()
        
        let player = YoutubePlayer()
        
        let playerView = player.getPlayerView();
        playerView.frame = CGRect(x: 0, y: 0, width: 200, height: 200)
        
        view.addSubview(playerView)
        player.play()
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
