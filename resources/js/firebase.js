// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAnw4KRz1hFrrs4636Ie1tW__8DgeSAK5E",
  authDomain: "multientrega-b0737.firebaseapp.com",
  projectId: "multientrega-b0737",
  storageBucket: "multientrega-b0737.appspot.com",
  messagingSenderId: "779964350319",
  appId: "1:779964350319:web:117a20bbfd6fca021b329a",
  measurementId: "G-ZDPR8YEQ22"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);