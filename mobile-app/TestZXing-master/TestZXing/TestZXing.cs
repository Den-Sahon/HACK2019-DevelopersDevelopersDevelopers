using System;

using Xamarin.Forms;

namespace TestZXing
{
    public class App : Application
    {
        [Obsolete]
        public App()
        {
            
            Button b = new Button() {
                Text = "СТАРТ !",
                HorizontalOptions = LayoutOptions.Center,
                BackgroundColor = Color.DodgerBlue,
                TextColor = Color.White,
                BorderRadius = 50,
            };

            b.Clicked += async (sender, e) => {
                await Application.Current.MainPage.Navigation.PushAsync(new ScanPage());
            };
           

            // The root page of your application
            var content = new ContentPage
            {
                Title = "M4ME",
                BackgroundColor = Color.White,

                Content = new StackLayout
                {
                    VerticalOptions = LayoutOptions.Center,
                    Children = {
                        new Label {
                            HorizontalTextAlignment = TextAlignment.Center,
                            TextColor = Color.Black,
                            FontSize = 30,
                            HorizontalOptions = LayoutOptions.Center,
                            Text = "ПРИВЕТ!\n"  +
                            "ДАВАЙТЕ НАЧНЁМ !"
                        }, b,
                        new Label {
                               Text = "Powered by MasterCard",
                                HorizontalOptions = LayoutOptions.Center,
                                TextColor = Color.Black,
                                VerticalOptions = LayoutOptions.Center,
                        }, 
                    }
                }
            };

          
            MainPage = new NavigationPage(content);
        }

        protected override void OnStart()
        {
            // Handle when your app starts
        }

        protected override void OnSleep()
        {
            // Handle when your app sleeps
        }

        protected override void OnResume()
        {
            // Handle when your app resumes
        }
    }
}
