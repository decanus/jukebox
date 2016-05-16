//
// Created by Dean Eigenmann on 09/05/16.
// Copyright (c) 2016 jukebox. All rights reserved.
//

import UIKit
import AVFoundation

class TabBarController: UITabBarController, UITabBarControllerDelegate, PlayerDelegate {

    private let player: Player
    private var songTitle: UILabel!
    // @todo seperate class
    private let playerBar: UIView!
    
    init(player: Player) {
        self.player = player
        
        playerBar = UIView()
        
        super.init(nibName: nil, bundle: nil)
        delegate = self
        
        let topBorder = CALayer()
        topBorder.frame = CGRect(x: 0, y: 0, width: view.frame.size.width, height: 0.5)
        topBorder.backgroundColor = UIColor.lightGrayColor().CGColor
        

        playerBar.frame = CGRect(
            x: 0,
            y: view.frame.size.height - (tabBar.frame.size.height * 2),
            width: view.frame.size.width,
            height: tabBar.frame.size.height
        )
        
        playerBar.layer.addSublayer(topBorder)
        
        songTitle = UILabel()
        songTitle.textColor = UIColor.blackColor()
        songTitle.font = UIFont.systemFontOfSize(14)
        playerBar.addSubview(songTitle)
        playerBar.hidden = true
        view.addSubview(playerBar)
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
    }
    
    func player(player: Player, shouldUpdatePlaybackState state: PlaybackState) {
        if state != .Stopped {
            playerBar.hidden = false
        }
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
}
