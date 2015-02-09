//
//  LogInViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 27/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit

class LogInViewController: UIViewController, UITextFieldDelegate {
    
    @IBOutlet weak var Label: UILabel!
    
    @IBOutlet weak var identifiantTextField: UITextField!
    
    @IBOutlet weak var MDPTextField: UITextField!
    
    
    override func viewDidLoad() {
        super.viewDidLoad();
        self.identifiantTextField.delegate = self
        self.MDPTextField.delegate = self
        self.title = "Connexion"//Modification du titre de la view
        var user: String? = NSUserDefaults.standardUserDefaults().stringForKey("userName")
        var pass: String? = NSUserDefaults.standardUserDefaults().stringForKey("passWord")
        if user != nil && pass != nil{
            var userText=NSAttributedString(string: user!)
            identifiantTextField.attributedText=userText
            var passText = NSAttributedString(string: pass!)
            MDPTextField.attributedText = passText
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    //Referme le clavier au clique sur la view
    func textFieldShouldReturn(textField: UITextField!) -> Bool {
        self.view.endEditing(true);
        return false;
    }
    
    override func touchesBegan(touches: NSSet, withEvent event: UIEvent) {
        self.view.endEditing(true)
    }
    
    //Bouton de connexion pressé
    @IBAction func connectionPush(sender: UIButton) {
        if identifiantTextField.text.isEmpty || MDPTextField.text.isEmpty {
            showAlert()
        }else{
            println("User : \(identifiantTextField.text)")
            println("Pass : \(MDPTextField.text)")
            var userName = NSUserDefaults.standardUserDefaults()
            userName.setValue(identifiantTextField.text, forKey: "userName")
            userName.synchronize()
            var passWord = NSUserDefaults.standardUserDefaults()
            passWord.setValue(MDPTextField.text, forKey: "passWord")
            passWord.synchronize()
            updateConnectionState(1)
        }
    }
    
    @IBAction func supprimerPush(sender: UIButton) {
        var userName = NSUserDefaults.standardUserDefaults()
        userName.setValue("", forKey: "userName")
        userName.synchronize()
        var passWord = NSUserDefaults.standardUserDefaults()
        passWord.setValue("", forKey: "passWord")
        passWord.synchronize()
        identifiantTextField.attributedText = nil
        MDPTextField.attributedText = nil
        updateConnectionState(0)
    }
    
    //Fonction affichant l'alert (les champs sont mal rempli)
    func showAlert(){
        let alertController = UIAlertController(title: "Erreur !", message:
            "Vous n'avez pas rempli tous les champs !", preferredStyle: UIAlertControllerStyle.Alert)
        alertController.addAction(UIAlertAction(title: "ok", style: UIAlertActionStyle.Default,handler: nil))
        
        self.presentViewController(alertController, animated: true, completion: nil)
    }
    
    
    func updateConnectionState(state: Int){

        let UUID = UIDevice.currentDevice().identifierForVendor.UUIDString
        let myUrl = NSURL(string: "http://localhost:8888/php/update-login.php");
        
        let request = NSMutableURLRequest(URL:myUrl!);
        request.HTTPMethod = "POST";
        
        // Compose a query string
        let postString = "DeviveID=\(UUID)&LogIn=\(state)";
        
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding);
        
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            
            if error != nil
            {
                println("error=\(error)")
                return
            }
            
            // You can print out response object
            println("response = \(response)")
            
            // Print out response body
            let responseString = NSString(data: data, encoding: NSUTF8StringEncoding)
            println("responseString = \(responseString)")
            
            
        }
        
        task.resume()
    }
    
    
    
}
