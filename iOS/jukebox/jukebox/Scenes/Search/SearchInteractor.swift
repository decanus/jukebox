//
//  SearchInteractor.swift
//  jukebox
//
//  Created by Dean Eigenmann on 15/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation

class SearchInteractor: NSObject, SearchViewControllerOutput {
    
    var tracks: [Track]? = [
        YoutubeTrack(id: "Bag1gUxuU0g", duration: 287),
        YoutubeTrack(id: "Bag1gUxuU0g", duration: 287),
        YoutubeTrack(id: "Bag1gUxuU0g", duration: 287)
    ]
    
    func trackForIndex(index: Int) -> Track {
        return YoutubeTrack(id: "Bag1gUxuU0g", duration: 287)
    }
    
}