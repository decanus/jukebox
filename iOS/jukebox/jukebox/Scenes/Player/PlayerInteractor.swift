//
//  PlayerInteractor.swift
//  jukebox
//
//  Created by Dean Eigenmann on 13/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class PlayerInteractor: NSObject, PlayerViewControllerOutput {
    
    private var output: PlayerInteractorOutput
    private let player: Player
    
    init(output: PlayerInteractorOutput, player: Player) {
        self.output = output
        self.player = player
    }
    
    func viewDidLoad() {
        player.delegate = output
    }
    
    func pausePressed() {
        if player.getPlaybackState() == .Playing {
            player.pause()
            return
        }
        
        player.play()
    }
    
    func nextPressed() {
        player.next()
    }
    
    func backPressed() {
        player.previous()
    }
    
    func closePressed() {
        player.delegate = nil
    }
    
}