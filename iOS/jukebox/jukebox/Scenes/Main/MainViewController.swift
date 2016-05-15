//
//  MainViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit
import AVFoundation

class MainViewController: UIViewController {

    private var player: Player!
    private var audioSession: AVAudioSession!
    private var wasLoaded = false
    
    init(player: Player) {
        self.player = player
        super.init(nibName: nil, bundle: nil)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        UIApplication.sharedApplication().statusBarStyle = .Default

        tabBarItem.title = "foo"
        navigationController?.navigationBarHidden = true
        view.backgroundColor = UIColor.whiteColor()
        
        let button = UIButton(frame: CGRect(x: 10, y: 10, width: 100, height: 100))
        button.setTitle("player", forState: .Normal)
        button.backgroundColor = UIColor.redColor()
        button.addTarget(self, action: #selector(open), forControlEvents: .TouchUpInside)
        view.addSubview(button)
        
        if !wasLoaded {
            player.addToQueue(YoutubeTrack(id: "bpOSxM0rNPM", duration: 265))
            player.addToQueue(YoutubeTrack(id: "QnxpHIl5Ynw", duration: 297))
            player.addToQueue(YoutubeTrack(id: "jcF5HtGvX5I", duration: 122))
            player.addToQueue(YoutubeTrack(id: "JCT_lgJ5eq8", duration: 205))
            wasLoaded = true
        } 
    }
    
    @objc func open() {
        presentViewController(ViewControllerFactory.createPlayerViewController(), animated: true, completion: nil)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
