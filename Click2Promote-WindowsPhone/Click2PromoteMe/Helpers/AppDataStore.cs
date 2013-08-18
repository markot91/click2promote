using System;
using System.Collections.Generic;
using System.IO;
using System.IO.IsolatedStorage;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Shapes;

namespace Click2PromoteMe.Helpers
{
    public class AppDataStore
    {
        private const string DataStoreKey = "app.data.store";

        private IsolatedStorageFile IsolatedStore
        {
            get
            {
                return IsolatedStorageFile.GetUserStoreForApplication();
            }
        }

        public List<string> GetAppSettings()
        {
            List<string> settings = new List<string>();

            FileMode fileMode;
            if (!IsolatedStore.FileExists(DataStoreKey))
                fileMode = FileMode.Create;
            else
                fileMode = FileMode.Open;

            using (IsolatedStorageFileStream fs = new IsolatedStorageFileStream(
                        DataStoreKey, fileMode, IsolatedStore))
            {
                var data = JSONNETSerializationHelper.Deserialize(fs, typeof(List<string>));
                if (data != null)
                {
                    settings = data as List<string>;
                }
            }

            return settings;
        }

        public void SetAppSettings(List<string> settings)
        {
            using (IsolatedStorageFileStream fs = new IsolatedStorageFileStream(
                        DataStoreKey, FileMode.Create, IsolatedStore))
            {
                JSONNETSerializationHelper.Serialize(fs, settings);
            }
        }
    }
}
