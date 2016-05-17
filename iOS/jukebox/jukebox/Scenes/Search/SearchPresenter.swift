//
//  SearchPresenter.swift
//  jukebox
//
//  Created by Dean Eigenmann on 17/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class SearchPresenter: SearchInteractorOutput {
    
    weak private var output: SearchPresenterOutput!
    
    init(output: SearchPresenterOutput) {
        self.output = output
    }
    
    func presentTracks(tracks: [Track]) {
        output.displayTracks(tracks)
    }
    
}
