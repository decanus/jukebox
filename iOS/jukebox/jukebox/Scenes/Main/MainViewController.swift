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
    
    override func viewDidLoad() {
        super.viewDidLoad()

        view.backgroundColor = UIColor.whiteColor()
        audioSession = AVAudioSession.sharedInstance()
        
        player = Player(youtubePlayer: YoutubePlayer())
        player.playTrack(YoutubeTrack())
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
