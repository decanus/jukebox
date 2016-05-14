//
//  PlayerViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit
import CoreMedia

// @todo add loading animation
class PlayerViewController: UIViewController, PlayerPresenterOutput {
    
    var output: PlayerViewControllerOutput!
    
    private var slider: UISlider!
    private var durationLabel: UILabel!
    private var elapsedLabel: UILabel!
    private var currentTime: UILabel!
    private var trackTitle: UILabel!
    private var source: UIButton!
    private var artworkView: UIView!

    override func viewDidLoad() {
        super.viewDidLoad()
        tabBarItem.title = "Player"
        navigationController?.navigationBarHidden = true
        UIApplication.sharedApplication().statusBarStyle = .LightContent
        view.backgroundColor = UIColor.blackColor()
        
        artworkView = UIView(frame: CGRect(x: 0, y: 0, width: view.frame.size.width, height: view.frame.size.width))
        view.addSubview(artworkView)
        
        let closeButton = UIButton(frame: CGRect(x: 16, y: UIApplication.sharedApplication().statusBarFrame.size.height + 16, width: 17, height: 10))
        closeButton.alpha = 0.85
        closeButton.setImage(UIImage(named: "chevron"), forState: .Normal)
        closeButton.imageView?.contentMode = .Top
        closeButton.addTarget(self, action: #selector(PlayerViewController.close), forControlEvents: .TouchDown)
        view.addSubview(closeButton)
        
        slider = UISlider(frame: CGRect(x: 0, y: view.frame.size.width - (13 / 2), width: view.frame.size.width, height: 13))
        slider.maximumValueImage = nil
        slider.minimumValue = 0
        slider.maximumValue = 0
        slider.setThumbImage(UIImage(named: "scrubber-button"), forState: .Normal)
        slider.minimumTrackTintColor = UIColor.lightPurpleColor()
        slider.tintColor = UIColor.lightPurpleColor()
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

        trackTitle = UILabel(frame: CGRect(x: 0, y: 0, width: 0, height: 0))
        trackTitle.textColor = UIColor.whiteColor()
        trackTitle.font = UIFont.boldSystemFontOfSize(18)
        view.addSubview(trackTitle)

        source = UIButton(type: .System)
        source.setTitleColor(UIColor.whiteColor(), forState: .Normal)
        source.titleLabel?.font = source.titleLabel?.font.fontWithSize(14)
        view.addSubview(source)

        let playButton = PlayButton(frame: CGRect(x: (view.frame.size.width / 2) - 40, y: 501, width: 80, height: 80))
        playButton.addTarget(self, action: #selector(PlayerViewController.pause), forControlEvents: .TouchUpInside)
        view.addSubview(playButton)

        let previous = UIButton(frame: CGRect(x: (view.frame.size.width / 2) - (40 + 40 + 31), y: 501 - (21 / 2) + 40, width: 31, height: 21))
        previous.addTarget(self, action: #selector(PlayerViewController.previous), forControlEvents: .TouchUpInside)
        previous.setImage(UIImage(named: "previous"), forState: .Normal)
        view.addSubview(previous)

        let next = UIButton(frame: CGRect(x: (view.frame.size.width / 2) + 40 + 40, y: 501 - (21 / 2) + 40, width: 31, height: 21))
        next.addTarget(self, action: #selector(PlayerViewController.next), forControlEvents: .TouchUpInside)
        next.setImage(UIImage(named: "next"), forState: .Normal)
        view.addSubview(next)
        output.viewDidLoad()
    }
    
    func setTrackTitle(title: String) {
        trackTitle.text = title
        trackTitle.sizeToFit()
        trackTitle.center = CGPoint(x: view.frame.width / 2, y: durationLabel.frame.maxY + 19 + trackTitle.frame.height / 2)
    }
    
    func setCurrentPlatform(platform: Platform) {
        source.setTitle(platform.rawValue.uppercaseString, forState: .Normal)
        source.sizeToFit()
        source.center = CGPoint(x: view.frame.width / 2, y: view.frame.height - source.frame.height - 16 + source.frame.height / 2)
    }

    func setPlayerProgressSliderValue(value: Float) {
        slider.setValue(value, animated: true)
    }
    
    func setMaximumSliderValue(value: Float) {
        slider.maximumValue = value
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
    
    @objc func close() {
        output.closePressed()
        dismissViewControllerAnimated(true, completion: nil)
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
