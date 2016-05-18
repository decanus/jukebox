//
//  SearchInteractor.swift
//  jukebox
//
//  Created by Dean Eigenmann on 15/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import Foundation
import Alamofire

class SearchInteractor: NSObject, SearchViewControllerOutput {
    
    private let output: SearchInteractorOutput
    private var tracks: [Track] = []
    
    init(output: SearchInteractorOutput) {
        self.output = output
    }
    
    func searchForText(search: String) {
        
        if search == "" {
            return
        }
        
        // @todo load tracks somewhere else, move this ugly shit
        Alamofire.request(
            .GET,
            "http://devapi.jukebox.ninja/v1/search",
            parameters: ["query": search, "key": "5eecc5da-0ff0-4aa0-98a0-ebcdfab3336c"]
            )
            .validate()
            .responseJSON { (response) -> Void in
                if response.result.isSuccess {
                    self.tracks = []
                    if let json = response.result.value as? NSArray {
                        for item in json {
                            if let trackJson = item as? NSDictionary {
                                self.tracks.append(
                                    YoutubeTrack(id: (trackJson["id"] as! String), duration: 0, title: (trackJson["title"] as! String), artist: (trackJson["artistName"] as! String))
                                )
                            }
                        }
                    }
                }
        }
        
        output.presentTracks(tracks)
    }
    
}