//
// Created by Dean Eigenmann on 09/05/16.
// Copyright (c) 2016 jukebox. All rights reserved.
//

import UIKit
import AVFoundation

class TabBarController: UITabBarController, UITabBarControllerDelegate, PlayerDelegate {

    private let player: Player
    private var songTitle: UILabel!
    private var albumTitle: UILabel!
    // @todo seperate class
    private let playerBar: UIView!
    private var button: UIButton
    
    init(player: Player) {
        self.player = player
        
        playerBar = UIView()
        button = UIButton()
        
        super.init(nibName: nil, bundle: nil)
        delegate = self
        
        let topBorder = CALayer()
        topBorder.frame = CGRect(x: 0, y: 0, width: view.frame.size.width, height: 0.5)
        topBorder.backgroundColor = UIColor.lighterGray().CGColor
        
        playerBar.frame = CGRect(
            x: 0,
            y: view.frame.size.height - (tabBar.frame.size.height * 2),
            width: view.frame.size.width,
            height: tabBar.frame.size.height
        )
        
        playerBar.layer.addSublayer(topBorder)
        
        let recognizer = UITapGestureRecognizer(target: self, action: #selector(self.openPlayerView))
//        recognizer.delegate = self
        recognizer.numberOfTapsRequired = 1
        playerBar.addGestureRecognizer(recognizer)
        
        songTitle = UILabel()
        songTitle.textColor = UIColor.blackColor()
        songTitle.font = UIFont.systemFontOfSize(14)
        
        albumTitle = UILabel()
        albumTitle.textColor = UIColor.grayColor()
        albumTitle.font = UIFont.systemFontOfSize(10)
        
        button.setImage(UIImage(named: "player-bar-play"), forState: .Normal)
        button.frame = CGRect(x: 16, y: 19, width: 16, height: 16)
        button.addTarget(self, action: #selector(TabBarController.pausePressed), forControlEvents: .TouchUpInside)
        
        playerBar.addSubview(songTitle)
        playerBar.addSubview(albumTitle)
        playerBar.addSubview(button)
        playerBar.hidden = true
        view.addSubview(playerBar)
    }
    
    func openPlayerView() {
        presentViewController(ViewControllerFactory.createPlayerViewController(), animated: true, completion: nil)
    }
    
    func player(player: Player, shouldUpdateElapsedTime elapsedTime: CMTime) {
        
    }
    
    func player(player: Player, shouldUpdateDuration duration: CMTime) -> Bool {
        return true
    }
    
    func player(player: Player, canPresentVideoLayer videoLayer: AVPlayerLayer) {
        
    }
    
    func player(player: Player, shouldUpdateTrack track: Track) {
        songTitle.text = track.getTitle()
        songTitle.sizeToFit()
        songTitle.center = CGPoint(x: view.frame.width / 2, y: 10 + songTitle.frame.height / 2)
        
        albumTitle.text = "foo"
        albumTitle.sizeToFit()
        albumTitle.center = CGPoint(x: view.frame.width / 2, y: songTitle.frame.size.height + songTitle.frame.origin.y + songTitle.frame.height / 2)
    }
    
    func player(player: Player, shouldUpdatePlaybackState state: PlaybackState) {
        if state != .Stopped {
            playerBar.hidden = false
        }
        
        if state == .Playing {
            button.setImage(UIImage(named: "player-bar-pause"), forState: .Normal)
            return
        }
        
        button.setImage(UIImage(named: "player-bar-play"), forState: .Normal)
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidAppear(animated: Bool) {
        super.viewDidAppear(animated)
        
        player.delegate = self
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.selectedIndex = 0
    }
    
    func pausePressed() {
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()
    }
}
