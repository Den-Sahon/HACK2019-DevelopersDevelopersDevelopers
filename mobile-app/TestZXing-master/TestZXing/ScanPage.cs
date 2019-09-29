using System;

using Xamarin.Forms;
using ZXing.Net.Mobile.Forms;
using System.Net.Http;
using System.Text.RegularExpressions;

namespace TestZXing
{
	public class ScanPage : ContentPage
	{
		ZXingScannerPage scanPage;
		Button buttonScanDefaultOverlay;
        Button buttonScanCustomPage;
        Editor textEditor;
        Label LabelText;
     

        [Obsolete]
        public ScanPage() : base()
		{

            
            buttonScanDefaultOverlay = new Button
			{
				Text = "НАЧАТЬ СКАНИРОВАНИЕ !",
				AutomationId = "scanWithDefaultOverlay",
                HorizontalOptions = LayoutOptions.Center,
                BackgroundColor = Color.DodgerBlue,
                VerticalOptions = LayoutOptions.CenterAndExpand,
                
                TextColor = Color.White,
                BorderRadius = 50,
                
            };
            LabelText = new Label
            {
                Text = "Введите номер телефона",
                HorizontalTextAlignment = TextAlignment.Center,
                TextColor = Color.Black,
                FontSize = 20,
                HorizontalOptions = LayoutOptions.Center,
                VerticalOptions = LayoutOptions.Start,


            };
            textEditor = new Editor
            {
                TextColor = Color.Black,
                FontSize = 25,
                HorizontalOptions = LayoutOptions.Center,
                VerticalOptions = LayoutOptions.CenterAndExpand,
                HeightRequest = 60,
                WidthRequest = 300, 
            };

            buttonScanDefaultOverlay.Clicked += async delegate {
				scanPage = new ZXingScannerPage();
				scanPage.OnScanResult += (result) => {
					scanPage.IsScanning = false;

                    Device.BeginInvokeOnMainThread((Action)(async () => {
                        await Navigation.PopAsync();
                        //await DisplayAlert("This is result Scanning", result.Text, "OK");
                        HttpContent content = new StringContent (result.Text + "/" + textEditor.Text);
                       // await DisplayAlert("text", Convert.ToString(content), "OK");
                        HttpClient client = new HttpClient();
                        //await DisplayAlert("text", Convert.ToString(client),"OK");
                        HttpResponseMessage response = await
                         client.PostAsync("http://95.213.39.143:80?check=check", content);
                        //await DisplayAlert("text", Convert.ToString(response.Content), "OK");
                   
                    }));
				};

				await Navigation.PushAsync(scanPage);
			};

            buttonScanCustomPage = new Button
            {
                Text = "Help on MasterCard.com",
                HorizontalOptions = LayoutOptions.Center,
                BackgroundColor = Color.Orange,
                TextColor = Color.White,
                VerticalOptions = LayoutOptions.CenterAndExpand,
                BorderRadius = 50,
            };
            buttonScanCustomPage.Clicked += async delegate {
                
            };


            var stack = new StackLayout();
            
            stack.Children.Add(buttonScanDefaultOverlay);
            stack.Children.Add(LabelText);
            stack.Children.Add(textEditor);
            stack.Children.Add(buttonScanCustomPage);
  


            Content = stack;
		}
	}
}

