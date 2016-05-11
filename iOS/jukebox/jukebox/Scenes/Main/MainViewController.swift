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

        navigationController?.navigationBarHidden = true
        view.backgroundColor = UIColor.whiteColor()
        
        
        if !wasLoaded {
            player.addToQueue(YoutubeTrack(id: "jcF5HtGvX5I"))
            player.addToQueue(YoutubeTrack(id: "JCT_lgJ5eq8"))
            wasLoaded = true
        }
        
        player.play()
        
        let tab = tabBarController as! TabBarController
        tab.video()
        
//        self.presentViewController(ViewControllerFactory.createPlayerViewController(), animated: true, completion: nil)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
