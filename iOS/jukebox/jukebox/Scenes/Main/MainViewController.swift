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

    private var player: YoutubePlayer!
    private var audioSession: AVAudioSession!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        view.backgroundColor = UIColor.whiteColor()
        audioSession = AVAudioSession.sharedInstance()
//        
//        do {
//            try audioSession.setCategory(AVAudioSessionCategoryPlayback)
//            
//            do {
//                try AVAudioSession.sharedInstance().setActive(true)
//                print("AVAudioSession is Active")
//            } catch let error as NSError {
//                print(error.localizedDescription)
//            }
//            
//        } catch let error as NSError {
//            print(error.localizedDescription)
//        }
        
        player = YoutubePlayer(audioSession: audioSession)
        player.setTrack(YoutubeTrack())
        player.appendPlayerToView(view)
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

}
