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
    private var slider: UISlider!
    
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
        self.player.setPlayerViewController(self)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        tabBarItem.title = "Player"
        navigationController?.navigationBarHidden = true
        UIApplication.sharedApplication().statusBarStyle = .LightContent
        view.backgroundColor = UIColor.blackColor()
        
        let back = UIView(frame: CGRect(x: 0, y: 0, width: view.frame.size.width, height: view.frame.size.width))
        back.backgroundColor = UIColor.grayColor()
        view.addSubview(back)
        
        slider = UISlider(frame: CGRect(x: 0, y: view.frame.size.width - (13 / 2), width: view.frame.size.width, height: 13))
        slider.maximumValueImage = nil
        slider.minimumValue = 0
        slider.maximumValue = 122.833
        slider.minimumTrackTintColor = UIColor.lightPurpleColor()
        slider.tintColor = UIColor.lightPurpleColor()
        slider.thumbTintColor = UIColor.lightPurpleColor()
        view.addSubview(slider)
        
        let playButton = PlayButton(frame: CGRect(x: (view.frame.size.width / 2) - 40, y: 501 - 40, width: 80, height: 80))
        playButton.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        view.addSubview(playButton)
        
        let previous = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - (40 + 40 + 31), y: 501 - (21 / 2), width: 31, height: 21))
        previous.addTarget(self, action: #selector(PlayerViewController.previous), forControlEvents: .TouchUpInside)
        previous.setImage(UIImage(named: "previous"), forState: .Normal)
        view.addSubview(previous)
        
        let next = UIButton(frame: CGRect(x: (view.frame.size.width / 2) + 40 + 40, y: 501 - (21 / 2), width: 31, height: 21))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.setImage(UIImage(named: "next"), forState: .Normal)
        view.addSubview(next)
    }
    
    func updateSlider(time: Float) {
        slider.setValue(time, animated: true)
    }
    
    // @move to presenter & interactor
    @objc func pause() {
                
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()

    }
    
    @objc func previous() {
        player.previous()
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
