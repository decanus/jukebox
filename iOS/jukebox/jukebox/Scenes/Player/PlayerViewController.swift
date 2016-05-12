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
        UIApplication.sharedApplication().statusBarStyle = .LightContent
        

        view.backgroundColor = UIColor.blackColor()
        
        // @todo, create pause button class which includes this
        let circlePath = UIBezierPath(
            arcCenter: CGPoint(x: (view.frame.size.width / 2), y: 501),
            radius: CGFloat(40),
            startAngle: CGFloat(0),
            endAngle:CGFloat(M_PI * 2),
            clockwise: true
        )
        
        let shapeLayer = CAShapeLayer()
        shapeLayer.path = circlePath.CGPath
        shapeLayer.fillColor = UIColor(red: 155 / 255, green: 80 / 255, blue: 186 / 255, alpha: 1).CGColor
        shapeLayer.strokeColor = UIColor(red: 155 / 255, green: 80 / 255, blue: 186 / 255, alpha: 1).CGColor
        shapeLayer.lineWidth = 3.0
        view.layer.addSublayer(shapeLayer)
        
        let pause = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - 40, y: 501 - (80 / 2), width: 80, height: 80))
        pause.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        pause.setImage(UIImage(named: "play"), forState: .Normal)
        pause.imageView?.frame.size = CGSize(width: 20, height: 24)
        pause.imageView?.contentMode = .Center
        view.addSubview(pause)
        
        let previous = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - (40 + 40 + 31), y: 501 - (21 / 2), width: 31, height: 21))
        previous.addTarget(self, action: #selector(PlayerViewController.previous), forControlEvents: .TouchUpInside)
        previous.setImage(UIImage(named: "previous"), forState: .Normal)
        view.addSubview(previous)
        
        let next = UIButton(frame: CGRect(x: (view.frame.size.width / 2) + 40 + 40, y: 501 - (21 / 2), width: 31, height: 21))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.setImage(UIImage(named: "next"), forState: .Normal)
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
