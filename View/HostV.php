<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.12.2014.
 * Time: 17:43
 */

class HostV {
    public function displayView(){
        ?>

        <link href="css/host.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
        <script src="js/host.js" type="text/javascript"></script>
        <div ng-app="hostApp" ng-controller="hostCtrl" class="mainHolder">

            <div class="menu">
                <div class="menuItem" ng-click="toggleFunc(1)">
                    Restaurants
                </div>
                <div class="menuItem" ng-click="toggleFunc(2)">
                    Meals
                </div>
                <div class="menuItem" ng-click="toggleFunc(3)">
                    Stock
                </div>
                <div class="menuItem" ng-click="toggleFunc(4)">
                    Reservations
                </div>
                <div class="menuItem" ng-click="toggleFunc(5)">
                    Orders
                </div>
            </div>

            <div class="mainContent">
                <!-- First functionality : Adding, editing and deleting restaurants -->
                <div class="functionalityWindow func1">

                    <!-- Add new restaurant button, red -->
                    <button class="newBtn newResBtn" ng-click="toggleShow(1)">Add new restaurant</button>

                    <!-- Form for entering information about new restaurant -->
                    <div class="newRestaurantHolder">

                        <!-- Part 1 : info about restaurant -->
                        <div class="newRestaurantPart">
                            <h4>Add new restaurant</h4>
                            <p>{{newRestaurantError}}</p><br>
                            <label>Name</label>
                            <input type="text" ng-model="newRestaurant.name" /><br>


                            <label>Description</label>
                            <textarea ng-model="newRestaurant.description"></textarea><br>


                            <label>Contact</label>
                            <input type="text" ng-model="newRestaurant.contact" /><br>


                            <label>Address</label>
                            <input type="text" ng-model="newRestaurant.address" /><br>

                            <label>City</label>
                            <input type="text" ng-model="newRestaurant.city" /><br>

                            <label>Picture URL</label>
                            <input type="text" ng-model="newRestaurant.picture" /><br>

                        </div>

                        <!-- Part 2 : capacity information -->
                        <div class="newRestaurantPart">
                            <h4>Capacity</h4>
                            <p>{{newRestaurantCapacityError}}</p><br>
                            <label>Table capacity</label>
                            <!-- How many chairs are at the table -->
                            <input type="number" min=1 ng-model="tableCapacity"/><br>

                            <label>Number of tables</label>
                            <!-- How many exact tables are there -->
                            <input type="number" min=1 ng-model="numberOfTables"/>
                            <br>
                            <button ng-click="addSeating()" class="addBtn">Add seating</button>
                            <br><br>

                            <!-- Table icons -->
                            <div class="tables" ng-repeat="(index,place) in seatingPlaces">
                                <div class="table">{{index}}</div>
                                <div class="seatingNumber">= {{place}}</div>
                                <img src="resources/images/delete.png" ng-click="removeSeating(index)" />
                            </div>
                        </div>
                        <br>

                        <!-- Confirmation buttons -->
                        <button class="saveBtn saveResBtn" ng-click="saveNewRestaurant()">Save</button>
                        <button class="saveEditBtn saveResEditBtn" ng-click="saveEditedRestaurant()">Update</button>
                        <button class="cancelBtn" ng-click="toggleShow(2)">Cancel</button>
                    </div>

                    <!-- List of existing restaurants -->
                    <div class="restaurantsHolder">
                        <div ng-repeat="restaurant in restaurants" class="restaurantPreview">
                            <img ng-src="{{restaurant.picture}}" class="restaurantImagePreview" />
                            <div class="restaurantDetails">
                                <h2 class="restaurantName">{{ restaurant.name }}</h2>
                                <p class="restaurantDescription">
                                    {{ restaurant.address + ", " + restaurant.city}} <br>
                                    {{ restaurant.contact }} <br>
                                    {{ restaurant.description.substr(0,50) + "..." }}
                                </p>
                            </div><br>
                            <button class="editBtn editResBtn" ng-click="editRestaurant(this)">Edit</button>
                            <button class="cancelBtn" ng-click="deleteRestaurant(this)">Delete</button>
                        </div>
                    </div>
                </div>


                <!-- Adding, updating and deleting meals -->
                <div class="functionalityWindow func2">

                    <select ng-options="restaurant.name for restaurant in restaurants" ng-model="selectMealRestaurant" ng-change="getMeals(); getMealCategories()">
                        <option value="" disabled>-- Choose your restaurant --</option>
                    </select>
                    <br>

                    <!-- Add new restaurant button, red -->
                    <button class="newBtn newMealBtn" ng-click="toggleShow(4)">Add new meal</button>

                    <!-- Form for entering information about new restaurant -->
                    <div class="newMealHolder">

                        <!-- Part 1 : info about restaurant -->
                        <div class="newMealPart">
                            <h4>Add new meal</h4>
                            <p>{{newMealError}}</p><br>
                            <label>Name</label>
                            <input type="text" ng-model="newMeal.name" /><br>


                            <label>Price</label>
                            <input type="number" ng-model="newMeal.price" /> kn<br>

                            <label>Category</label>
                            <select ng-options="category.name for category in categories" ng-model="newMeal.category" ng-change="getMeals(); getMealCategories()">
                                <option value="" >No category</option>
                            </select><br>

                            <label>Available</label>
                            <input type="checkbox" ng-model="newMeal.available"
                                   ng-true-value="1" ng-false-value="0"/><br>
                        </div>

                        <!-- Part 2 : capacity information -->
                        <div class="newMealPart">
                            <h4>Ingredients</h4>
                            <p>{{newNormativeError}}</p><br>
                            <label>Ingredient</label>
                            <select ng-options="ingredient.name for ingredient in ingredients" ng-model="ingredient">
                                <option value="" disabled>-- Select ingredient --</option>
                            </select><br>

                            <label>Normative</label>
                            <input type="number" min=1 ng-model="ingredientAmount"/>
                            <select ng-model="ingredientUnit">
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="l">l</option>
                                <option value="dcl">dcl</option>
                                <option value="kom">kom</option>
                            </select>

                            <br>
                            <button ng-click="addNormative()" class="addBtn">Add normative</button>
                            <br><br>

                            <!-- Table icons -->
                            <table class="normativeTable">
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                                <tr ng-repeat="(index,value) in normative">
                                    <td>{{index}}</td>
                                    <td>{{value.amount}} {{value.unit}}</td>
                                    <td><img src="resources/images/delete.png" ng-click="removeNormative(index)"></td>
                                </tr>
                            </table>
                        </div>
                        <br>

                        <!-- Confirmation buttons -->
                        <button class="saveBtn saveMealBtn" ng-click="saveMeal()">Save</button>
                        <button class="saveEditBtn saveMealEditBtn" ng-click="saveEditedMeal()">Update</button>
                        <button class="cancelBtn" ng-click="toggleShow(5)">Cancel</button>
                    </div>

                    <!-- List of existing restaurants -->
                    <div class="mealsHolder">
                        <input type="text" ng-model="mealFilter" placeholder="Quick search"/>
                        <br>

                        <div ng-repeat="meal in meals | filter:mealFilter" class="meal">
                            <h3>{{ meal.name }}</h3>
                            <p>Price: {{ meal.price }} kn</p>
                            <p>Norm: {{ getMealDescription(meal.normative) }}</p>
                            <p>{{ availability(meal.available)}}</p><br>
                            <button class="editBtn editMealBtn" ng-click="editMeal(this)">Edit</button>
                        </div>
                    </div>
                </div>

                <!-- Stock preview functionality -->
                <div class="functionalityWindow func3">
                    Stock
                </div>

                <!-- Reservations functionality -->
                <div class="functionalityWindow func4">
                    Reservations
                </div>

                <!-- Orders functionality -->
                <div class="functionalityWindow func5">
                    Orders
                </div>
            </div>
        </div>





<?php
    }
} 