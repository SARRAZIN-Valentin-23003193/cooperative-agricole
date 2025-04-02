package com.example.commande;


public class Commande {

    
    protected String command_id;

 
    protected String pickup_location;


    protected String withdrawal_date;



 
    public Commande(){
    }

    /**
     * Constructeur 
     * @param command_id référence
     * @param pickup_location titre
     * @param withdrawal_date auteurs du livre
     */
    public Commande(String command_id, String pickup_location, String withdrawal_date){
        this.command_id = command_id;
        this.pickup_location = pickup_location;
        this.withdrawal_date = withdrawal_date;
    }

    public String getCommande_id() {
        return command_id;
    }

    public void setCommand_id(String command_id) {
        this.command_id = command_id;
    }

    public String getPickup_location() {
        return pickup_location;
    }

    public void setPickup_location(String pickup_location){
        this.pickup_location = pickup_location;
    }

    public String getWithdrawal_date() {
        return withdrawal_date;
    }

    public void setWithdrawal_date(String withdrawal_date) {
        this.withdrawal_date = withdrawal_date;
    }


    @Override
    public String toString() {
        return "Commande{" +
                "command_id='" + command_id + '\'' +
                ", pickup_location='" + pickup_location + '\'' +
                ", withdrawal_date='" + withdrawal_date + '\'' +
                '}';
    }
}