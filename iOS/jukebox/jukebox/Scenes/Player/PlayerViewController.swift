//
//  PlayerViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit
import CoreMedia

class PlayerViewController: UIViewController, PlayerPresenterOutput {
    
    var output: PlayerViewControllerOutput!
    
    private var slider: UISlider!
    private var durationLabel: UILabel!
    private var elapsedLabel: UILabel!
    private var currentTime: UILabel!
    private var artworkView: UIView!

    override func viewDidLoad() {
        super.viewDidLoad()
        tabBarItem.title = "Player"
        navigationController?.navigationBarHidden = true
        UIApplication.sharedApplication().statusBarStyle = .LightContent
        view.backgroundColor = UIColor.blackColor()
        
        artworkView = UIView(frame: CGRect(x: 0, y: 0, width: view.frame.size.width, height: view.frame.size.width))
        view.addSubview(artworkView)
        
        slider = UISlider(frame: CGRect(x: 0, y: view.frame.size.width - (13 / 2), width: view.frame.size.width, height: 13))
        slider.maximumValueImage = nil
        slider.minimumValue = 0
        slider.maximumValue = 0
        slider.minimumTrackTintColor = UIColor.lightPurpleColor()
        slider.tintColor = UIColor.lightPurpleColor()
        slider.thumbTintColor = UIColor.lightPurpleColor()
        view.addSubview(slider)
        
        elapsedLabel = UILabel(frame: CGRect(x: 16, y: 375 + 16, width: 100, height: 14))
        elapsedLabel.textColor = UIColor.whiteColor()
        elapsedLabel.font.fontWithSize(14)
        elapsedLabel.textAlignment = .Left
        elapsedLabel.text = "--:--"
        view.addSubview(elapsedLabel)
        
        durationLabel = UILabel(frame: CGRect(x: view.frame.size.width - (100 + 16), y: 375 + 16, width: 100, height: 14))
        durationLabel.textColor = UIColor.whiteColor()
        durationLabel.font.fontWithSize(14)
        durationLabel.textAlignment = .Right
        durationLabel.text = "--:--"
        view.addSubview(durationLabel)
        
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
    
    func setPlayerProgressSliderValue(value: Float) {
        slider.setValue(value, animated: true)
    }
    
    func updateElapsedTimeLabel(elapsedTime: String) {
        elapsedLabel.text = elapsedTime
    }
    
    func frameForVideoLayer() -> CGRect {
        return artworkView.frame
    }
    
    func appendPlayerVideoToCoverView(playerVideo: UIView) {
        artworkView.addSubview(playerVideo)
    }
    
    func updateDurationLabel(duration: String) {
        durationLabel.text = duration
    }
    
    @objc func pause() {
        output.pausePressed()

    }
    
    @objc func previous() {
        output.backPressed()
    }
    
    @objc func next() {
        output.nextPressed()
    }
}
