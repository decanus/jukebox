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
        tabBarItem.title = "Player"
        navigationController?.navigationBarHidden = true

        view.backgroundColor = UIColor.blackColor()
        
        let pause = UIButton(frame: CGRect(x: 10, y: 100, width: 50, height: 25))
        pause.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        pause.backgroundColor = UIColor.redColor()
        view.addSubview(pause)
        
        
        let next = UIButton(frame: CGRect(x: 70, y: 100, width: 50, height: 25))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.backgroundColor = UIColor.redColor()
        next.setTitle("Next", forState: .Normal)
        view.addSubview(next)

    }
    
    // @move to presenter & interactor
    @objc func pause() {
                
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()

    }
    
    @objc func next() {
        player.next()
    }
    
    // --
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
