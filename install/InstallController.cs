using System;
using System.IO;
using System.Net;
using System.Text;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json.Linq;

namespace WebApplication2.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class InstallController : ControllerBase
    {
        private void Log(string msg)
        {
            using (StreamWriter sw = System.IO.File.AppendText("log.txt"))
            {
                sw.WriteLine(String.Format("{0}: {1}", DateTime.Now, msg));
            }
        }

        // GET api/install/code
        [HttpGet()]
        public ActionResult<string> Get(string code)
        {
            string oAuthAccessToken = GetOAuthAccessToken(code);
            string apiAccessToken = GetApiAccessToken(oAuthAccessToken);
            string text = GetEshopInfo(apiAccessToken);
            return text;
        }

        private string GetOAuthAccessToken(string code)
        {
            Log(String.Format("Installation with code '{0}'", code));

            using (WebClient client = new WebClient())
            {
                try
                {
                    var postData = new System.Collections.Specialized.NameValueCollection();
                    postData.Add("redirect_uri", "https://webinstallapplication.azurewebsites.net/api/install");
                    postData.Add("client_id", "3owcl3g1imxdltpp");
                    postData.Add("client_secret", "UZL8GIl9CkEhERCwUItT8ErwLFAUL4dW");
                    postData.Add("code", code);
                    postData.Add("scope", "api");
                    postData.Add("grant_type", "authorization_code");

                    byte[] responsebytes = client.UploadValues("https://eliska.myshoptet.com/action/ApiOAuthServer/token", "POST", postData);
                    string responsebody = Encoding.UTF8.GetString(responsebytes);
                    Log(Response.StatusCode + ": " + responsebody);

                    JObject json = JObject.Parse(responsebody);
                    string oAuthAccessToken = (string)json["access_token"];
                    Log("Your OAuth Access Token: " + oAuthAccessToken);

                    return oAuthAccessToken;
                }
                catch (WebException e)
                {
                    var response = new StreamReader(e.Response.GetResponseStream()).ReadToEnd();
                    Log(String.Format("WebException {0}: {1}", e.Message, response));
                }

                return "n/a";
            }
        }

        private string GetApiAccessToken(string oAuthAccessToken)
        {
            Log("GetApiAccessToken");

            using (WebClient client = new WebClient())
            {
                try
                {
                    client.Headers.Add("Authorization", "Bearer " + oAuthAccessToken);
                    string response = client.DownloadString("https://eliska.myshoptet.com/action/ApiOAuthServer/getAccessToken");
                    Log(response);

                    JObject json = JObject.Parse(response);
                    string apiAccessToken = (string)json["access_token"];
                    Log("Your API Access Token: " + apiAccessToken);

                    return apiAccessToken;
                }
                catch (WebException e)
                {
                    var response = new StreamReader(e.Response.GetResponseStream()).ReadToEnd();
                    Log(String.Format("WebException {0}: {1}", e.Message, response));
                }

                return "n/a";
            }
        }

        private string GetEshopInfo(string apiAccessToken)
        {
            Log("GetEshopInfo");

            string msg = "";

            using (WebClient client = new WebClient())
            {
                try
                {
                    client.Headers.Add("Shoptet-Access-Token", apiAccessToken);
                    client.Headers.Add("Content-type", "application/vnd.shoptet.v1.0");
                    msg = client.DownloadString("https://api.myshoptet.com/api/eshop");

                    JObject json = JObject.Parse(msg);
                    string eshopId = (string)json["data"]["contactInformation"]["eshopId"];
                    string url = (string)json["data"]["contactInformation"]["url"];
                    string name = (string)json["data"]["contactInformation"]["eshopName"];
                    msg += String.Format("\nEshopId: {0} Url: {1} Název: {2}", eshopId, url, name);
                }
                catch (WebException e)
                {
                    var response = new StreamReader(e.Response.GetResponseStream()).ReadToEnd();
                    msg = String.Format("WebException {0}: {1}", e.Message, response);
                }
            }

            Log(msg);

            return msg;
        }
    }
}
