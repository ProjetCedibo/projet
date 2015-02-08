//
//  LeftMenuView.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit

class LeftMenuView: UITableViewController{
 
    @IBOutlet weak var moodleIcon: UIImageView!
    @IBOutlet weak var AdeIcon: UIImageView!
    @IBOutlet weak var WebMailIcon: UIImageView!
    @IBOutlet weak var BUIcon: UIImageView!
    @IBOutlet weak var SJEPGIcon: UIImageView!
    @IBOutlet weak var GinkoIcon: UIImageView!
    @IBOutlet weak var ActuIcon: UIImageView!
    @IBOutlet weak var ContactIcon: UIImageView!
    
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
 
    
    @IBAction func MoodlePush(sender: UIButton) {
        let vc = WebViewController(nibName: "WebViewController", bundle: nil)
        navigationController?.pushViewController(vc, animated: true)
    }
    
    @IBAction func ADEPush(sender: UIButton) {
    }
    
    
    
}

