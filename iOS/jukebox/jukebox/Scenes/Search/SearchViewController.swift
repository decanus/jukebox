//
//  SearchViewController.swift
//  jukebox
//
//  Created by Dean Eigenmann on 09/05/16.
//  Copyright © 2016 jukebox. All rights reserved.
//

import UIKit

class SearchViewController: UIViewController, SearchPresenterOutput {
 
    var output: SearchViewControllerOutput!
    private let searchController: UISearchController
    private let tableView: UITableView
    private var tracks: [Track] = []
    
    init() {
        searchController = UISearchController(searchResultsController: nil)
        tableView = UITableView()
        super.init(nibName: nil, bundle: nil)
        tableView.frame = view.frame
        tabBarItem = UITabBarItem(title: nil, image: UIImage(named: "search"), tag: 1)
        tabBarItem.imageInsets = UIEdgeInsetsMake(6, 0, -6, 0);
    }
    
    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        navigationController?.navigationBarHidden = false

        searchController.dimsBackgroundDuringPresentation = false
        searchController.hidesNavigationBarDuringPresentation = false
        searchController.searchResultsUpdater = self
        navigationItem.titleView = searchController.searchBar
        definesPresentationContext = true
        
        tableView.delegate = self
        tableView.dataSource = self
        tableView.separatorStyle = .None
        tableView.allowsMultipleSelection = false
        view.addSubview(tableView)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func displayTracks(tracks: [Track]) {
        self.tracks = tracks

        dispatch_async(dispatch_get_main_queue(), {
            self.tableView.reloadData()
        })
    }
    
}

extension SearchViewController: UISearchResultsUpdating {
    
    func updateSearchResultsForSearchController(searchController: UISearchController) {
        output.searchForText(searchController.searchBar.text!)
        
    }
    
}

extension SearchViewController: UITableViewDelegate {
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        PlayerFactory.createPlayer().playTrack(tracks[indexPath.row])
    }
    
}

extension SearchViewController: UITableViewDataSource {

    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return tracks.count
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        return TrackCell(track: tracks[indexPath.row])
    }
    
}