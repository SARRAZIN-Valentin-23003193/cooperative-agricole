package fr.univamu.iut.panier;

/**
 * Classe représentant un panier
 */
public class Panier {

    /**
     * Id du panier
     */
    protected String basket_id;

    /**
     * Nom du panier
     */
    protected String name;

    /**
     * Quantité du panier
     */
    protected String quantity;

    /**
     * Prix du panier
     */
    protected String price;

    /**c
     * Constructeur par défaut
     */
    public Panier(){
    }

    /**
     * Constructeur de panier
     * @param basket_id id du panier
     * @param name nom du panier
     * @param quantity quantité du panier
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