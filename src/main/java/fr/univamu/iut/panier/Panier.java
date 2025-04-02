package fr.univamu.iut.panier;

/**
 * Classe représentant un livre
 */
public class Panier {

    /**
     * Référence du livre
     */
    protected String basket_id;

    /**
     * titre du livre
     */
    protected String name;

    /**
     * Auteurs du livre
     */
    protected String quantity;

    /**
     * Statut du livre
     * ('r' pour réservé, 'e' pour emprunté, et 'd' pour disponible)
     */
    protected String price;

    /**c
     * Constructeur par défaut
     */
    public Panier(){
    }

    /**
     * Constructeur de livre
     * @param basket_id référence du livre
     * @param name titre du livre
     * @param quantity auteurs du livre
     * @param price prix du panier
     */
    public Panier(String basket_id, String name, String quantity, String price){
        this.basket_id = basket_id;
        this.name = name;
        this.quantity = quantity;
        this.price = price;
    }

    public String getBasket_id() {
        return basket_id;
    }

    public void setBasket_id(String basket_id) {
        this.basket_id = basket_id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }

    @Override
    public String toString() {
        return "Panier{" +
                "basket_id='" + basket_id + '\'' +
                ", name='" + name + '\'' +
                ", quantity='" + quantity + '\'' +
                ", price='" + price + '\'' +
                '}';
    }
}