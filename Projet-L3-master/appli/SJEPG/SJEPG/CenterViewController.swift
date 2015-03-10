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
    @IBOutlet var eventsCollection: UICollectionView!
    
    var currentWeek: Int = 0
    var events: NSArray = []
    
    override func viewDidLoad() {
        super.viewDidLoad();
        
        // Observer qui permet d'actualiser l'affichage apres la récupération des evenements a afficher.
        NSNotificationCenter.defaultCenter().addObserver(self, selector: "refresh", name: "GetAgendaDidComplete", object: nil)
        
        //Fonction permettant de gèrer le menu
        if self.revealViewController() != nil {
            menuButton.target = self.revealViewController()
            menuButton.action = "revealToggle:"
        }
        //gestion de la taille du menu
        self.revealViewController().rearViewRevealWidth = 230
        
        //Récupération du numéro de la semaine courante.
        let calendar = NSCalendar.currentCalendar()
        let date = NSDate()
        let components = calendar.components(.MonthCalendarUnit | .DayCalendarUnit, fromDate: date)
        currentWeek = calendar.component(.CalendarUnitWeekOfYear, fromDate: date)
        currentWeek = currentWeek as NSInteger!
        println(currentWeek)
        //Appel a la fonction récupérant les données sur le serveur
        getAgenda(currentWeek)
        
        //Ajout de la reconaaissance des mouvement glisser de doigt
        var swipeRight = UISwipeGestureRecognizer(target: self, action: "respondToSwipeGesture:")
        swipeRight.direction = UISwipeGestureRecognizerDirection.Right
        self.view.addGestureRecognizer(swipeRight)
        
        var swipeLeft = UISwipeGestureRecognizer(target: self, action: "respondToSwipeGesture:")
        swipeLeft.direction = UISwipeGestureRecognizerDirection.Left
        self.view.addGestureRecognizer(swipeLeft)

        self.eventsCollection.backgroundColor = UIColor(hex: 0x130E0A, alpha: 0.9)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func numberOfSectionsInCollectionView(collectionView: UICollectionView) -> Int {
        return self.events.count
    }
    
    func collectionView(collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return 1
    }
    
    /*
    * Fonction qui créer une cellule pour chaque evenement de la semaine
    */
    func collectionView(collectionView: UICollectionView, cellForItemAtIndexPath indexPath: NSIndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCellWithReuseIdentifier("cellEventID", forIndexPath: indexPath) as EventCell
        cell.backgroundColor = UIColor.whiteColor()
        cell.agendaTitle.text = self.events[indexPath.section]["AgendaTitle"] as NSString
        cell.agendaTitle.font = UIFont.boldSystemFontOfSize(20.0)
        cell.layer.cornerRadius = 10
        cell.agendaType.text = self.events[indexPath.section]["AgendaMessage"] as NSString
        
        cell.agendaDate.text = self.events[indexPath.section]["AgendaDate"] as NSString
        var EvenType = self.events[indexPath.section]["AgendaType"] as NSString
        //coloration de la cellule en fonction de son type
        if EvenType == "SJEPG" {
            cell.backgroundColor = UIColor(hex: 0xFF335E, alpha: 0.5)
        }
        else if EvenType == "BU" {
            cell.backgroundColor = UIColor(hex: 0x0066FF, alpha: 0.5)
        }
        else {
            cell.backgroundColor = UIColor(hex: 0x33E700, alpha: 0.6)
        }
        println("création de cell")
        ProgressView.shared.hideProgressView()

        return cell
    }
    
    private let sectionInsets = UIEdgeInsets(top: 10.0, left: 20.0, bottom: 10.0, right: 10.0)
    
    func collectionView(collectionView: UICollectionView!,
        layout collectionViewLayout: UICollectionViewLayout!,
        insetForSectionAtIndex section: Int) -> UIEdgeInsets {
            return sectionInsets
    }
    
    func collectionView(collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAtIndexPath indexPath: NSIndexPath) -> CGSize {
        return CGSizeMake(300, 100)
    }
    
    /*func collectionView(collectionView: UICollectionView!,
        layout collectionViewLayout: UICollectionViewLayout!,
        sizeForItemAtIndexPath indexPath: NSIndexPath!) -> CGSize {
        println("cell size")
        return CGSize(width: 360, height: 120)
    }*/
    
    
    /*
    * Gestion des evenement en cas de glisser
    * retour vers la semaine précedente ou aller a la semaine suivante
    */
    func respondToSwipeGesture(gesture: UIGestureRecognizer) {
        
        if let swipeGesture = gesture as? UISwipeGestureRecognizer {
            
            switch swipeGesture.direction {
            case UISwipeGestureRecognizerDirection.Right:
                println("Swiped right")
                self.currentWeek--
                getAgenda(currentWeek)
            case UISwipeGestureRecognizerDirection.Left:
                println("Swiped Left")
                self.currentWeek++
                getAgenda(currentWeek)
            default:
                break
            }
        }
    }
    
    /*
    * Récupération des données en fonction de la semaine passer en parametre
    * voir AppDelegate
    */
    func getAgenda(week: Int){
        ProgressView.shared.showProgressView(eventsCollection)
        let myURL = NSURL(string: "http://sjepg.byethost7.com/php/getAgenda.php")!
        let request = NSMutableURLRequest(URL: myURL)
        request.HTTPMethod = "POST"
        
        request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
        request.setValue("application/json", forHTTPHeaderField: "Accept")
        let bodyStr:String = "Week=\(week)"
        request.HTTPBody = bodyStr.dataUsingEncoding(NSUTF8StringEncoding)
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            var strData = NSString(data: data, encoding: NSUTF8StringEncoding)
            var err: NSError?
            var json = NSJSONSerialization.JSONObjectWithData(data, options: .MutableLeaves, error: &err) as? NSArray
            
            if(err != nil) {
                println(err!.localizedDescription)
                let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                println("Error could not parse JSON: '\(jsonStr)'")
            } else {
                if let parseJSON = json {
                    NSNotificationCenter.defaultCenter().postNotificationName("GetAgendaDidComplete", object:nil)
                    self.events = parseJSON
                    println(parseJSON)
                }
                else {
                    let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                    println("Error could not parse JSON: \(jsonStr)")
                }
            }
        }
        task.resume()
    }
    
    /*
    * Syncronisation des thread.
    */
    func refresh() {
        dispatch_async(dispatch_get_main_queue(), {
            self.eventsCollection.reloadData()
        })
        println("chargement....")
    }
    
}
