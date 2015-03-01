//
//  ViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit
import Foundation

class CenterViewController: UIViewController {

    
    @IBOutlet weak var menuButton:UIBarButtonItem!
    @IBOutlet weak var dcd: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad();
        if self.revealViewController() != nil {
            menuButton.target = self.revealViewController()
            menuButton.action = "revealToggle:"
            //self.view.addGestureRecognizer(self.revealViewController().panGestureRecognizer())
        }
        self.revealViewController().rearViewRevealWidth = 230
        //ProgressView.shared.showProgressView(view)
        dcd.layer.cornerRadius = 10.0
        dcd.clipsToBounds = true
        //getAgenda(7)
        
        //ProgressView.shared.hideProgressView()
    }
    
        

    

    
    
    
    //close the activity indicator
    func closeActivity() {
        ProgressView.shared.hideProgressView()
    }

}
